package Tests;

import static org.testng.Assert.assertEquals;

import java.io.FileInputStream;
import java.util.List;

import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import Repos.DemographicsPage;
import Repos.LoginPage;
import Repos.StudentHome;
import Repos.threePanelPage;
import Repos.vitalSignsPage;
import Repos.vitalSignsSectionPage;

public class VitalSignsTest {

	static XSSFWorkbook workBook; 
	static XSSFSheet sheet;
	static XSSFRow row;
	static int i=0;
	static int j=0;
	static Object[][] DataCellValues;

	@DataProvider(name="vitalSigns")
	//@Test
	public static Object[][] dataInputFromExcel() throws Exception
	{
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("VitalSigns");

		int k=sheet.getLastRowNum();//get the number of rows
		System.out.println(k);

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row
		System.out.println(l);
		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
				}


			}
		}
		System.out.println("got values");
		return DataCellValues;

	}


	//	@Test
	@Test(dataProvider="vitalSigns")
	public void testVitals(String username,String Password,String patientName,String BPS,String BPD,String HeartRate,String RespRate,
			String Temp,String TempUnit,String Weight,String WeightUnit,String height,
			String heightUnit,String pain,String OxygenSat,String comment,String values
			)throws Exception 
	{

		WebDriver driver = new FirefoxDriver();
		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(username);
		LoginPage.Password(driver).sendKeys(Password);
		LoginPage.Submit(driver).click();

		//name of the patient
		driver.findElement(By.partialLinkText(patientName)).click();
		Thread.sleep(5000);


		threePanelPage.vitalSignsTab(driver).click();

		//click on add new vs
		vitalSignsPage.addVital(driver).click();


		// assertEquals(vitalSignsPage.addVital(driver).isEnabled(), false); 

		//accept error
		// driver.switchTo().alert().accept();
		//pass the values
		Thread.sleep(5000);
		vitalSignsPage.BPS(driver).sendKeys(BPS);
		vitalSignsPage.BPD(driver).sendKeys(BPD);
		vitalSignsPage.heartRate(driver).sendKeys(HeartRate);
		vitalSignsPage.respRate(driver).sendKeys(RespRate);
		vitalSignsPage.temp(driver).sendKeys(Temp);	 
		Select se = new Select( vitalSignsPage.temp_Unit(driver));
		se.selectByValue(TempUnit);
		Thread.sleep(5000);
		vitalSignsPage.weight(driver).sendKeys(Weight);	
		Select se1 = new Select( vitalSignsPage.weightUnit(driver));
		se1.selectByValue(WeightUnit);
		Thread.sleep(5000);
		vitalSignsPage.height(driver).sendKeys(height);
		Select se2 = new Select( vitalSignsPage.heightUnit(driver));
		se2.selectByValue(heightUnit);
		Thread.sleep(5000);
		vitalSignsPage.pain(driver).sendKeys(pain);
		vitalSignsPage.oSaturation(driver).sendKeys(OxygenSat);
		vitalSignsPage.comment(driver).sendKeys(comment);
		Thread.sleep(2000);


//		threePanelPage.demographicsTb(driver).click();
//		driver.switchTo().alert().dismiss();





		vitalSignsPage.childsubmit(driver).sendKeys(Keys.ENTER);;
		Thread.sleep(5000);
		//check the table disappears
		//assertEquals(vitalSignsPage.addTable(driver), false);








		// Grab the table 
		WebElement table = vitalSignsPage.table(driver); 

		// Now get all the TR elements from the table 
		List<WebElement> allRows = table.findElements(By.tagName("tr")).subList(1, 2); 

		// And iterate over them, getting the cells 
		for (WebElement row : allRows) { 
			List<WebElement> cells = row.findElements(By.tagName("td")); 
			System.out.println(cells.size());
			int i=0;
			for(i=0;i<cells.size();i++)
			{

				System.out.println(cells.get(i).getText()+"    "+ i);
			} 

			assertEquals(cells.get(1).getText(), BPS);
			assertEquals(cells.get(2).getText(), BPD);
			assertEquals(cells.get(3).getText(), HeartRate);
			assertEquals(cells.get(4).getText(), RespRate);
			assertEquals(cells.get(5).getText(), Temp+" "+TempUnit);
			assertEquals(cells.get(6).getText(), Weight+" "+WeightUnit);
			assertEquals(cells.get(7).getText(), height+" "+heightUnit);
			assertEquals(cells.get(8).getText(), pain);
			assertEquals(cells.get(9).getText(), OxygenSat);
			assertEquals(cells.get(10).getText(), comment);


			//check if the vital signs is displayed on top

			assertEquals(vitalSignsSectionPage.bpdiastolic(driver).getText(), BPD); 
			assertEquals(vitalSignsSectionPage.bpsystolic(driver).getText(), BPS);
			assertEquals(vitalSignsSectionPage.oxygenSaturation(driver).getText(), OxygenSat);
			assertEquals(vitalSignsSectionPage.pain(driver).getText(), pain);
			assertEquals(vitalSignsSectionPage.temp(driver).getText(), Temp+" "+TempUnit);
			assertEquals(vitalSignsSectionPage.RespRate(driver).getText(), RespRate);

			threePanelPage.backToDashboard(driver).click();
			driver.findElement(By.partialLinkText(patientName)).click();
			Thread.sleep(5000);

			// Grab the table 
			WebElement table2 = vitalSignsPage.table(driver); 

			// Now get all the TR elements from the table 
			List<WebElement> allRows2 = table.findElements(By.tagName("tr")).subList(1, 2); 

			// And iterate over them, getting the cells 
			for (WebElement row2 : allRows2) { 
				List<WebElement> cells2 = row.findElements(By.tagName("td")); 
				System.out.println(cells.size());
				int j=0;
				for(j=0;j<cells.size();j++)
				{

					System.out.println(cells.get(j).getText()+"    "+ j);
				} 

				assertEquals(cells.get(1).getText(), BPS);
				assertEquals(cells.get(2).getText(), BPD);
				assertEquals(cells.get(3).getText(), HeartRate);
				assertEquals(cells.get(4).getText(), RespRate);
				assertEquals(cells.get(5).getText(), Temp+" "+TempUnit);
				assertEquals(cells.get(6).getText(), Weight+" "+WeightUnit);
				assertEquals(cells.get(7).getText(), height+" "+heightUnit);
				assertEquals(cells.get(8).getText(), pain);
				assertEquals(cells.get(9).getText(), OxygenSat);
				assertEquals(cells.get(10).getText(), comment);


				//check if the vital signs is displayed on top

				assertEquals(vitalSignsSectionPage.bpdiastolic(driver).getText(), BPD); 
				assertEquals(vitalSignsSectionPage.bpsystolic(driver).getText(), BPS);
				assertEquals(vitalSignsSectionPage.oxygenSaturation(driver).getText(), OxygenSat);
				assertEquals(vitalSignsSectionPage.pain(driver).getText(), pain);
				assertEquals(vitalSignsSectionPage.temp(driver).getText(), Temp+" "+TempUnit);
				assertEquals(vitalSignsSectionPage.RespRate(driver).getText(), RespRate);





				//cells..sendKeys(Keys.ENTER);


				//	     assertEquals(vitalSignsSectionPage.bpdiastolic(driver).getText().contains(BPD), true); 
				//	     assertEquals(vitalSignsSectionPage.bpsystolic(driver).getText().contains(BPS), false);
				//	     assertEquals(vitalSignsSectionPage.oxygenSaturation(driver).getText().contains(OxygenSat), false);
				//	     assertEquals(vitalSignsSectionPage.pain(driver).getText().contains(pain), false);
				//	     assertEquals(vitalSignsSectionPage.temp(driver).getText().contains(Temp+" "+TempUnit), false);
				//	     assertEquals(vitalSignsSectionPage.RespRate(driver).getText().contains(RespRate),false );
				//	      


				driver.close();
			}


		}
	}
}
